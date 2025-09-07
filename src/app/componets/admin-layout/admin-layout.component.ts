import { Component } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-admin-layout',
  templateUrl: './admin-layout.component.html',
  styleUrls: ['./admin-layout.component.css']
})
export class AdminLayoutComponent {

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
        this.auth.removeToken();
        this.router.navigate(['/login']);
      }
    });
  }
}
