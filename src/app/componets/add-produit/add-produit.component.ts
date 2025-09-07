import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { ProduitService } from '../../services/produit.service';
import { Produit } from '../../models/produit';
import { CategorieService } from '../../services/categorie.service';
import { Categorie } from '../../models/categorie';


@Component({
  selector: 'app-add-produit',
  templateUrl: './add-produit.component.html',
  styleUrls: ['./add-produit.component.css']
})
export class AddProduitComponent implements OnInit {
  id!: number;
  submitted = false;
  categories: Categorie[] = [];
  selectedFile: File | null = null;

  produitForm: FormGroup = new FormGroup({
    nom: new FormControl('', [Validators.required, Validators.minLength(2)]),
    description: new FormControl('', [Validators.required]),
    prix: new FormControl(0, [Validators.required, Validators.min(1)]),
    stock: new FormControl(0, [Validators.required, Validators.min(0)]),
    image_url: new FormControl(''),
    allergenes: new FormControl(''),
    id_categorie: new FormControl('', [Validators.required])
  });

  constructor(
    private produitService: ProduitService,
    private router: Router,
    private route: ActivatedRoute,
     private categorieService: CategorieService,
  ) {}

  ngOnInit(): void {

     this.categorieService.getAll().subscribe({
      next: (data) => (this.categories = data),
      error: (err) => console.error(err)
    });


    if (this.route.snapshot.paramMap.get('id')) {
      this.id = this.route.snapshot.params['id'];
      this.getById(this.id);
    }
  }

  getById(id: number) {
    this.produitService.getById(id).subscribe({
      next: (data: Produit) => {
        console.log(data);
        this.produitForm.patchValue(data);
      },
      error: (err) => console.error(err)
    });
  }

  get f() {
    return this.produitForm.controls;
  }

  // ✅ Récupérer le fichier sélectionné
  onFileSelected(event: any) {
    this.selectedFile = event.target.files[0];
  }

  onSubmit() {
  this.submitted = true;

  if (this.produitForm.valid) {
    // On prépare un FormData pour inclure texte + fichier
    const formData = new FormData();

    formData.append('nom', this.produitForm.value.nom);
    formData.append('description', this.produitForm.value.description);
    formData.append('prix', this.produitForm.value.prix);
    formData.append('stock', this.produitForm.value.stock);
    formData.append('allergenes', this.produitForm.value.allergenes);
    formData.append('id_categorie', this.produitForm.value.id_categorie);

    if (this.selectedFile) {
  formData.append('image_url', this.selectedFile, this.selectedFile.name);
}


    if (this.id) {
      // ✅ Update produit
      this.produitService.updateProduit(formData, this.id).subscribe({
        next: () => {
          console.log('Produit mis à jour');
          this.router.navigateByUrl('/admin/produits');
        },
        error: (err) => console.error(err)
      });
    } else {
      // ✅ Add produit
      this.produitService.addProduit(formData).subscribe({
        next: () => {
          console.log('Produit ajouté');
          this.router.navigateByUrl('/admin/produits');
        },
        error: (err) => console.error(err)
      });
    }
  }
}

}
