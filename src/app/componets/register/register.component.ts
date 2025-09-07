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
    next: (res: any) => {
      this.success = 'Utilisateur créé avec succès !';

      // Sauvegarde du token + infos utilisateur
      this.authService.saveToken(res.access_token);
      localStorage.setItem('role', res.user.role);
      localStorage.setItem('userId', res.user.id.toString());

      // Redirection selon rôle
      if (res.user.role === 'ADMIN') {
        this.router.navigate(['/admin']);
      } else if (res.user.role === 'EMPLOYE') {
        this.router.navigate(['/employe']);
      } else {
        this.router.navigate(['/client']);
      }
    },
    error: () => {
      this.error = 'Erreur lors de la création utilisateur.';
    }
  });
}

}
