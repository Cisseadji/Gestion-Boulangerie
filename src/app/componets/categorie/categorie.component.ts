import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Categorie } from '../../models/categorie';
import { CategorieService } from '../../services/categorie.service';

@Component({
  selector: 'app-categories',
  templateUrl: './categorie.component.html',
  styleUrls: ['./categorie.component.css']
})
export class CategorieComponent implements OnInit {

  categories: Categorie[] = [];

  constructor(private categorieService: CategorieService, private router: Router) {}

  ngOnInit(): void {
    this.getAll();
  }

  getAll() {
    this.categorieService.getAll().subscribe(
      (data: Categorie[]) => {
        this.categories = data;
      },
      (error) => {
        console.log(error);
      }
    );
  }

  deleteCategorie(id: number) {
    this.categorieService.deleteCategorie(id).subscribe(
      () => this.getAll(),
      (error) => console.log(error)
    );
  }
}
