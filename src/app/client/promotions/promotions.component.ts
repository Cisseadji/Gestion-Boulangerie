import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { PromotionService } from '../../services/promotion.service';
import { ProduitService } from '../../services/produit.service';
import { Promotion } from '../../models/promotion';

@Component({
  selector: 'app-promotion',
  templateUrl: './promotions.component.html',
  styleUrls: ['./promotions.component.css']
})
export class PromotionsComponent implements OnInit {

  promotions: Promotion[] = [];
  produits: any[] = [];
  promoForm!: FormGroup;
  editingId: number | null = null;
  loading: boolean = false;
  selectedProduits: number[] = [];

  constructor(
    private promotionService: PromotionService,
    private produitService: ProduitService,
    private fb: FormBuilder
  ) {}

  ngOnInit(): void {
    this.initForm();
    this.loadProduits();
    this.loadPromotions();
  }

  initForm() {
    this.promoForm = this.fb.group({
      titre: ['', Validators.required],
      description: ['', Validators.required],
      pourcentage_remise: [0, [Validators.required, Validators.min(0), Validators.max(100)]],
      date_debut: ['', Validators.required],
      date_fin: ['', Validators.required],
      produits: [[]],
      actif: [true]
    });
  }

  loadProduits() {
    this.produitService.getAll().subscribe(data => this.produits = data);
  }

  loadPromotions() {
    this.loading = true;
    this.promotionService.getAll().subscribe({
      next: (data) => {
        this.promotions = data.map(promo => ({
          ...promo,
          produits: promo.produits || []
        }));
        this.loading = false;
      },
      error: (err) => {
        console.error(err);
        this.loading = false;
      }
    });
  }

  openForm(promo?: Promotion) {
    this.editingId = promo?.id || null;
    if (promo) {
      this.selectedProduits = promo.produits.map(p => p.id);
      this.promoForm.patchValue({
        ...promo,
        produits: this.selectedProduits
      });
    } else {
      this.selectedProduits = [];
      this.promoForm.reset({ actif: true, produits: [] });
    }
    const modal = document.getElementById('promoModal');
    if (modal) (modal as any).style.display = 'block';
  }

  closeForm() {
    const modal = document.getElementById('promoModal');
    if (modal) (modal as any).style.display = 'none';
  }

  onProductToggle(prodId: number, event: Event) {
    const input = event.target as HTMLInputElement;
    if (input.checked) {
      if (!this.selectedProduits.includes(prodId)) this.selectedProduits.push(prodId);
    } else {
      this.selectedProduits = this.selectedProduits.filter(id => id !== prodId);
    }
  }

  onSubmit() {
    if (this.promoForm.invalid) return;

    const promo = {
      ...this.promoForm.value,
      produits: this.selectedProduits
    };

    if (this.editingId) {
      this.promotionService.updatePromotion(this.editingId, promo).subscribe({
        next: () => {
          this.loadPromotions();
          this.closeForm();
        }
      });
    } else {
      this.promotionService.addPromotion(promo).subscribe({
        next: () => {
          this.loadPromotions();
          this.closeForm();
        }
      });
    }
  }

  deletePromotion(id: number | undefined) {
    if (!id) return;
    if (confirm("Voulez-vous vraiment supprimer cette promotion ?")) {
      this.promotionService.deletePromotion(id).subscribe({
        next: () => this.loadPromotions(),
        error: (err) => console.error(err)
      });
    }
  }
}
