import { Component, OnInit } from "@angular/core";
import { Produit } from "../../models/produit";
import { ProduitService } from "../../services/produit.service";
import { CartService } from "../../services/carte.service";

@Component({
  selector: 'app-catalogue',
  templateUrl: './catalogue.component.html',
  styleUrls: ['./catalogue.component.css']
})
  export class CatalogueComponent implements OnInit {
  produits: Produit[] = [];
  categories: string[] = [];
  category = 'all';

  constructor(
    private produitService: ProduitService,
    private cart: CartService
  ) {}

ngOnInit(): void {
  this.produitService.getAll().subscribe(data => {
    this.produits = data.map(p => ({
      ...p,
      allergenes: p.allergenes ? p.allergenes.toString().split(',') : []  // sécurité si backend renvoie string
    }));

    // Extraire les catégories uniques (par nom)
    this.categories = [
      ...new Set(this.produits.map(p => p.id_categorie.nom))
    ];
  });
}


  ajouterpanier(p: Produit) {
     this.cart.add(p, 1);
  }
}

