import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Produit } from '../../models/produit';
import { ProduitService } from '../../services/produit.service';


@Component({
  selector: 'app-products',
  templateUrl: './produit.component.html',
  styleUrls: ['./produit.component.css']
})
export class ProduitComponent implements OnInit {

  produits: Produit[] = [];

  constructor(private produitService: ProduitService, private router: Router) {}

  ngOnInit(): void {
    this.getAll();
  }

  getAll() {
    this.produitService.getAll().subscribe(
      (data: Produit[]) => {
        this.produits = data;
      },
      (error) => console.log(error)
    );
  }

  deleteProduit(id: number) {
    this.produitService.deleteProduit(id).subscribe(
      () => this.getAll(),
      (error) => console.log(error)
    );
  }
}
