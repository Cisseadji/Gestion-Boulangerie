import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Commande } from '../../models/commande';
import { CommandeService } from '../../services/commande.service';

@Component({
  selector: 'app-commande',
  templateUrl: './commande.component.html',
  styleUrls: ['./commande.component.css']
})
export class CommandeComponent implements OnInit {

  commandes: Commande[] = [];
  role!: string;
  userId!: number;
  loading: boolean = false;

  constructor(private commandeService: CommandeService, private auth: AuthService) {}

  ngOnInit(): void {
    this.role = this.auth.getRole();
    this.userId = this.auth.getUserId();
    this.loadCommandes();
  }

  loadCommandes() {
    this.loading = true;
    this.commandeService.getAll().subscribe({
      next: (data) => {
        // Filtrer selon rôle
        if (this.role === 'CLIENT') {
          this.commandes = data.filter(c => c.id_client === this.userId);
        } else if (this.role === 'EMPLOYE') {
          // Employé : commandes en préparation ou prêtes uniquement
          this.commandes = data.filter(c => c.statut !== 'LIVREE');
        } else {
          // Admin/Gérant : toutes les commandes
          this.commandes = data;
        }
        this.loading = false;
      },
      error: (err) => {
        console.error(err);
        alert('Erreur lors du chargement des commandes.');
        this.loading = false;
      }
    });
  }

  updateStatut(id: number, statut: string) {
    if (this.auth.isEmploye() || this.auth.isAdmin() || this.role === 'GERANT') {
      this.commandeService.updateStatut(id, statut).subscribe({
        next: () => this.loadCommandes(),
        error: (err) => {
          console.error(err);
          alert('Impossible de mettre à jour le statut.');
        }
      });
    }
  }

  deleteCommande(id: number) {
    if (this.auth.isAdmin() || this.role === 'GERANT') {
      if (confirm('Voulez-vous vraiment supprimer cette commande ?')) {
        this.commandeService.deleteCommande(id).subscribe({
          next: () => this.loadCommandes(),
          error: (err) => console.error(err)
        });
      }
    }
  }
}
