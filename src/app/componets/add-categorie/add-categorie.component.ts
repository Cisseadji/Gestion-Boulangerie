import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { CategorieService } from '../../services/categorie.service';
import { Categorie } from '../../models/categorie';


@Component({
  selector: 'app-add-category',
  templateUrl: './add-categorie.component.html',
  styleUrls: ['./add-categorie.component.css']
})
export class AddCategorieComponent implements OnInit {
  id!: number;
  submitted = false;

  categoryForm: FormGroup = new FormGroup({
    nom: new FormControl('', [Validators.required, Validators.minLength(3)]),
  });

  constructor(
    private categorieService: CategorieService,
    private router: Router,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    if (this.route.snapshot.paramMap.get('id')) {
      this.id = +this.route.snapshot.params['id'];
      this.getById(this.id);
    }
  }

  getById(id: number) {
    this.categorieService.getById(id).subscribe(
      (data: Categorie) => {
        this.categoryForm.patchValue(data);
      },
      (error) => console.log(error)
    );
  }

  get f() {
    return this.categoryForm.controls;
  }

  onSubmit() {
    this.submitted = true;
    if (this.categoryForm.valid) {
      if (this.id) {
        this.categorieService.updateCategorie(this.categoryForm.value, this.id).subscribe(
          () => this.router.navigateByUrl('/admin/categories'),
          (error) => console.log(error)
        );
      } else {
        this.categorieService.addCategorie(this.categoryForm.value).subscribe(
          () => this.router.navigateByUrl('/admin/categories'),
          (error) => console.log(error)
        );
      }
    }
  }
}
