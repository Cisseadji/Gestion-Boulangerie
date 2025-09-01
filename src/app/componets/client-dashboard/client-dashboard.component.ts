import { Component } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-client-dashboard',
  templateUrl: './client-dashboard.component.html',
  styleUrl: './client-dashboard.component.css'
})
export class ClientDashboardComponent {
    constructor(private auth: AuthService, private router: Router) {}
    isAuthenticated(): boolean {
      return this.auth.isAuthenticated();
    }
  
    logOut() {
      this.auth.logOut().subscribe({
        next: () => {
          this.auth.removeToken();
          this.router.navigate(['/login']);
        },
        error: () => {
          // même en cas d'erreur backend, on nettoie côté frontend
          this.auth.removeToken();
          this.router.navigate(['/login']);
        }
      });
  
  }

}
