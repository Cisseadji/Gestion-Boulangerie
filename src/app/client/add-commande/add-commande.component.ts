import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators, FormArray } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { CommandeService } from '../../services/commande.service';
import { Commande } from '../../models/commande';
import { AuthService } from '../../services/auth.service';
import { ProduitCommande } from '../../models/produit-commande';

@Component({
  selector: 'app-add-commande',
  templateUrl: './add-commande.component.html',
  styleUrls: ['./add-commande.component.css']
})
export class AddCommandeComponent implements OnInit {
  id!: number;
  submitted = false;
  userId!: number;

  commandeForm: FormGroup = new FormGroup({
    total: new FormControl(null, [Validators.required, Validators.min(1)]),
    statut: new FormControl('EN_PREPARATION', [Validators.required]),
    mode_paiement: new FormControl('A_LA_LIVRAISON', [Validators.required]),
    adresse: new FormControl('', [Validators.required]),
    date_commande: new FormControl(new Date().toISOString().slice(0,16), [Validators.required]),
    produits: new FormArray([], [Validators.required])
  });

  constructor(
    private commandeService: CommandeService,
    private authService: AuthService,
    private router: Router,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.userId = this.authService.getUserId();

    if (this.route.snapshot.paramMap.get('id')) {
      this.id = this.route.snapshot.params['id'];
      this.getById(this.id);
    }
  }

  // FormArray getter
  get produits(): FormArray {
    return this.commandeForm.get('produits') as FormArray;
  }

  addProduitToForm(produit: ProduitCommande) {
    this.produits.push(
      new FormGroup({
        id: new FormControl(produit.id),
        nom: new FormControl(produit.nom),
        quantite: new FormControl(produit.quantite ?? 1, [Validators.required, Validators.min(1)]),
        prix_unitaire: new FormControl(produit.prix_unitaire ?? 0, [Validators.required, Validators.min(1)])
      })
    );
  }

  getById(id: number) {
    this.commandeService.getById(id).subscribe({
      next: (data: Commande) => {
        this.produits.clear();
        data.produits.forEach(p => this.addProduitToForm(p));
        this.commandeForm.patchValue({
          statut: data.statut,
          mode_paiement: data.mode_paiement,
          adresse: data.adresse,
          date_commande: data.date_commande.slice(0,16) // format input datetime-local
        });
      },
      error: (err) => console.error(err)
    });
  }

  get f() {
    return this.commandeForm.controls;
  }

  calculateTotal(): number {
    return this.produits.controls.reduce((sum, p) => {
      const val = p.value;
      return sum + (val.prix_unitaire * val.quantite);
    }, 0);
  }

  onSubmit() {
    this.submitted = true;

    if (this.commandeForm.valid) {
      const produits: ProduitCommande[] = this.produits.value.map((p: any) => ({
        id: p.id,
        nom: p.nom,
        quantite: p.quantite,
        prix_unitaire: p.prix_unitaire
      }));

      const commande: Commande = {
        ...this.commandeForm.value,
        id_client: this.userId,
        produits,
        total: this.calculateTotal(),
        date_commande: this.commandeForm.value.date_commande
      };

      if (this.id) {
        this.commandeService.updateCommande(this.id, commande).subscribe({
          next: () => this.router.navigateByUrl('/commande'),
          error: (err) => console.error(err)
        });
      } else {
        this.commandeService.addCommande(commande).subscribe({
          next: () => this.router.navigateByUrl('/commande'),
          error: (err) => console.error(err)
        });
      }
    }
  }
}
