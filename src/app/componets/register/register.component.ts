import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { Component } from '@angular/core';

@Component({
  selector: 'app-register-user',
  templateUrl: './register.component.html'
})
export class RegisterComponent  {
  form: FormGroup;
  success = '';
  error = '';

  constructor(private fb: FormBuilder, private authService: AuthService, private router: Router) {
     this.form = this.fb.group({
      nom: ['', Validators.required],
      prenom: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      telephone: ['', Validators.required],
      password: ['', Validators.required],
  
    });
  }


  register() {
    if (this.form.invalid) return;

    this.authService.register(this.form.value).subscribe({
      next: () => {
        this.success = 'Utilisateur créé avec succès !';
        setTimeout(() => this.router.navigate(['/admin/users']), 2000);
      },
      error: () => {
        this.error = 'Erreur lors de la création utilisateur.';
      }
    });
  }
}
