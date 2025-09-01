// livraisons.component.ts
import { Component, OnInit } from '@angular/core';
import { CommandeService } from '../../services/commande.service';
import { AuthService } from '../../services/auth.service';
import { Commande } from '../../models/commande';

@Component({
  selector: 'app-livraisons',
  templateUrl: './livraisons.component.html',
  styleUrls: ['./livraisons.component.css']
})
export class LivraisonsComponent implements OnInit {

  commandes: Commande[] = [];
  role!: string;
  userId!: number;

  constructor(private commandeService: CommandeService, private auth: AuthService) {}

  ngOnInit(): void {
    this.role = this.auth.getRole();
    this.userId = this.auth.getUserId();
    this.loadCommandes();
  }

  loadCommandes() {
    this.commandeService.getAll().subscribe(data => {
      if (this.role === 'CLIENT') {
        this.commandes = data.filter(c => 
          c.id_client === this.userId && 
          (c.statut === 'EN_LIVRAISON' || c.statut === 'LIVREE')
        );
      } else if (this.role === 'EMPLOYE') {
        this.commandes = data.filter(c => c.statut === 'PRETE' || c.statut === 'EN_LIVRAISON');
      } else {
        // ADMIN / GERANT : toutes les commandes
        this.commandes = data;
      }
    });
  }

  updateStatut(id: number, statut: string) {
    if (this.role === 'EMPLOYE' || this.role === 'ADMIN' || this.role === 'GERANT') {
      this.commandeService.updateStatut(id, statut).subscribe(() => this.loadCommandes());
    }
  }
}
