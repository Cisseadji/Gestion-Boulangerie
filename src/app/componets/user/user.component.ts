import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { TokenResponse } from '../../models/token-response';


@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrl: './user.component.css'
})
export class UserComponent {
  form: FormGroup;
  constructor(private fb: FormBuilder, private auth: AuthService, private router: Router) {
    this.form = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required]
    });
  }


  login() {
  if (this.form.valid) {
    this.auth.login(this.form.value).subscribe({
      next: (res: TokenResponse) => {
        this.auth.saveToken(res.access_token);
        localStorage.setItem('role', res.user.role);
        localStorage.setItem('userId', res.user.id.toString());

        const role = res.user.role;
        if (role === 'ADMIN') {
          this.router.navigate(['/admin']);
        } else if (role === 'EMPLOYE') {
          this.router.navigate(['/employe']);
        } else {
          this.router.navigate(['/client']);
        }
      },
      error: (err) => {
        if (err.status === 404) {
          alert("Vous n'avez pas de compte, veuillez vous inscrire.");
        } else if (err.status === 401) {
          alert("Mot de passe incorrect.");
        } else if (err.status === 403) {
          alert("Votre compte est désactivé, contactez l’administrateur.");
        } else {
          alert("Erreur lors de la connexion.");
        }
      }
    });
  }
}


goToRegister() {
  // Redirige simplement vers la page d'inscription
  this.router.navigate(['/register']);
}
}
