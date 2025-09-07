import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { DashboardService } from '../../services/dashboard.service';
import { Commande } from '../../models/commande';
import { Produit } from '../../models/produit';
import { Promotion } from '../../models/promotion';

@Component({
  selector: 'app-admin-dashboard',
  templateUrl: './admin-dashboard.component.html',
  styleUrls: ['./admin-dashboard.component.css']
})
export class AdminDashboardComponent implements OnInit {

  stats = {
    totalCommandes: 0,
    commandesEnCours: 0,
    chiffreAffaires: 0,
    nouveauxClients: 0
  };

  commandesRecentes: Commande[] = [];
  produitsPopulaires: (Produit & { ventes: number, evolution: string })[] = [];
  promotions: Promotion[] = [];
  ventesData: { ventes: number; periode: string }[] = [];

  constructor(
    private auth: AuthService,
    private router: Router,
    private dashboardService: DashboardService
  ) {}

  ngOnInit(): void {
    this.loadDashboardData();
    this.loadVentesData();
  }

  loadDashboardData(): void {
    this.dashboardService.getStats().subscribe(data => this.stats = data);
    this.dashboardService.getCommandesRecentes().subscribe(data => {
      console.log('Commandes récentes:', data);
      this.commandesRecentes = data;
    });
    this.dashboardService.getProduitsPopulaires().subscribe(data => {
      console.log('Produits populaires:', data);
      this.produitsPopulaires = data;
    });
    this.dashboardService.getPromotions().subscribe(data => this.promotions = data);
  }

  loadVentesData(): void {
    this.dashboardService.getVentes().subscribe(data => {
      console.log('Ventes:', data);
      this.ventesData = data;
    });
  }


  getStatutClass(statut: string): string {
    switch(statut) {
      case 'EN_PREPARATION': return 'badge bg-warning text-dark';
      case 'PRETE': return 'badge bg-info text-dark';
      case 'EN_LIVRAISON': return 'badge bg-primary';
      case 'LIVREE': return 'badge bg-success';
      default: return 'badge bg-secondary';
    }
  }
}
