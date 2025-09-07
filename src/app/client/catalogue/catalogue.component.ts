import { Component, OnInit } from "@angular/core";
import { Produit } from "../../models/produit";
import { ProduitService } from "../../services/produit.service";
import { CartService } from "../../services/carte.service";
import { Promotion } from "../../models/promotion";
import { PromotionService } from "../../services/promotion.service";

@Component({
  selector: 'app-catalogue',
  templateUrl: './catalogue.component.html',
  styleUrls: ['./catalogue.component.css']
})
  export class CatalogueComponent implements OnInit {
  produits: Produit[] = [];
  categories: string[] = [];
  category = 'all';
   promotions: Promotion[] = [];

  constructor(
    private produitService: ProduitService,
    private cart: CartService,
    private promoService: PromotionService
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


  this.promoService.getAll().subscribe(data => {
      this.promotions = data;
    });
}
  ajouterpanier(p: Produit) {
  if (p.stock <= 0) {
    alert("Produit en rupture de stock !");
    return;
  }
  this.cart.add(p, 1);
}


  
}

