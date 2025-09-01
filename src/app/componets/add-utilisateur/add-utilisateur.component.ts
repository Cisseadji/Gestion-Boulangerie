import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { UserService } from '../../services/user.service';
import { User } from '../../models/user';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-add-utilisateur',
  templateUrl: './add-utilisateur.component.html',
  styleUrl: './add-utilisateur.component.css'
})
export class AddUtilisateurComponent {

  id!: number;
  submitted = false;

  userForm: FormGroup = new FormGroup({
    nom: new FormControl('', [Validators.required, Validators.minLength(2)]),
    prenom: new FormControl('', [Validators.required]),
    email: new FormControl('', [Validators.required, Validators.email]),
    telephone: new FormControl('', [Validators.required]),
    password: new FormControl('', [Validators.required]), // obligatoire en ajout
    role: new FormControl('', [Validators.required]),
    actif: new FormControl(true)
  });

  constructor(
    private userService: UserService,
    private router: Router,
    private route: ActivatedRoute,
  ) {}

  ngOnInit(): void {
    if (this.route.snapshot.paramMap.get('id')) {
      this.id = this.route.snapshot.params['id'];
      this.getById(this.id);
    }
  }

  getById(id: number) {
    this.userService.getById(id).subscribe({
      next: (data: User) => {
        this.userForm.patchValue(data);
        // en update, password n’est pas obligatoire
        this.userForm.get('password')?.clearValidators();
        this.userForm.get('password')?.updateValueAndValidity();
      },
      error: (err) => console.error(err)
    });
  }

  get f() {
    return this.userForm.controls;
  }

  onSubmit() {
    this.submitted = true;

    if (this.userForm.valid) {
      const user: User = this.userForm.value;

      if (this.id) {
        // ✅ Update
        this.userService.updateUser(this.id, user).subscribe({
          next: () => {
            console.log('Utilisateur mis à jour');
            this.router.navigateByUrl('/admin/utilisateur');
          },
          error: (err) => console.error(err)
        });
      } else {
        // ✅ Add
        this.userService.addUser(user).subscribe({
          next: () => {
            console.log('Utilisateur ajouté');
            this.router.navigateByUrl('/admin/utilisateur');
          },
          error: (err) => console.error(err)
        });
      }
    }
  }
}
