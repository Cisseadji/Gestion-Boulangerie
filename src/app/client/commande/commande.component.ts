import { Component, OnInit } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { Commande } from '../../models/commande';
import { CommandeService } from '../../services/commande.service';
import { AuthService } from '../../services/auth.service';

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

  selectedCommande!: Commande; // commande pour le modal

  constructor(
    private commandeService: CommandeService,
    private auth: AuthService,
    private modalService: NgbModal
  ) {}

  ngOnInit(): void {
    this.role = this.auth.getRole();
    this.userId = this.auth.getUserId();
    this.loadCommandes();
  }

  loadCommandes() {
    this.loading = true;
    this.commandeService.getAll().subscribe({
      next: (data) => {
        if (this.role === 'CLIENT') {
          this.commandes = data.filter(c => c.id_client === this.userId);
        } else if (this.role === 'EMPLOYE') {
          this.commandes = data.filter(c => c.statut !== 'LIVREE');
        } else {
          this.commandes = data;
        }
        this.loading = false;
      },
      error: () => this.loading = false
    });
  }

  // Vérifications rôle
  isAdmin() {
    return this.auth.isAdmin();
  }

  isEmploye() {
    return this.auth.isEmploye();
  }

  isClient() {
    return this.auth.isClient();
  }

  // Actions
  changerStatut(commande: Commande) {
    this.commandeService.updateStatut(commande.id, commande.statut).subscribe({
      next: () => console.log('Statut mis à jour !'),
      error: () => console.error('Erreur mise à jour statut')
    });
  }

  modifierCommande(commande: Commande) {
    console.log("Modifier commande :", commande);
    // TODO : ouvrir un formulaire ou rediriger vers une page édition
  }

  supprimerCommande(id: number) {
    if (confirm("Voulez-vous vraiment supprimer cette commande ?")) {
      this.commandeService.deleteCommande(id).subscribe({
        next: () => this.loadCommandes(),
        error: () => console.error("Erreur suppression commande")
      });
    }
  }

  openDetailModal(modal: any, commande: Commande) {
    this.selectedCommande = commande;
    this.modalService.open(modal, { size: 'lg', scrollable: true });
  }
}
