import { Component, OnInit } from '@angular/core';
import { Commande } from '../../models/commande';
import { Livraison } from '../../models/livraison';
import { CommandeService } from '../../services/commande.service';
import { LivraisonService } from '../../services/livraison.service';

@Component({
  selector: 'app-livraison',
  templateUrl: './add-livraison.component.html',
  styleUrls: ['./add-livraison.component.css']
})
export class AddLivraisonComponent implements OnInit {
  commandesPretes: Commande[] = [];
  livraisons: Livraison[] = [];
  loading = false;
  successMsg = '';
  errorMsg = '';

  constructor(
    private commandeService: CommandeService,
    private livraisonService: LivraisonService
  ) {}

  ngOnInit(): void {
    this.loadCommandesPretes();
    this.loadLivraisons();
  }

  // Charger les commandes PRETE
  loadCommandesPretes() {
    this.loading = true;
    this.commandeService.getAll().subscribe({
      next: (data) => {
        this.commandesPretes = data.filter(c => c.statut === 'PRETE');
        this.loading = false;
      },
      error: () => {
        this.loading = false;
        this.errorMsg = 'Erreur lors du chargement des commandes';
      }
    });
  }

  // Charger toutes les livraisons
  loadLivraisons() {
    this.livraisonService.getAll().subscribe({
      next: (data) => {
        this.livraisons = data;
      },
      error: () => {
        this.errorMsg = 'Erreur lors du chargement des livraisons';
      }
    });
  }

  // Créer une livraison depuis une commande PRETE
creerLivraison(cmd: Commande) {
  const statutLivraison: Livraison['statut'] = 'EN_COURS';

  // On calcule la date prévue automatiquement (ex: +2 jours)
  const datePrevue = new Date();
  datePrevue.setDate(datePrevue.getDate() + 2);

  const data: Partial<Livraison> = {
    id_commande: cmd.id,
    adresse: cmd.adresse,
    statut: statutLivraison,
    date_prevue: datePrevue.toISOString()  // format compatible avec Laravel
  };

  this.livraisonService.store(data).subscribe({
    next: () => {
      this.successMsg = `✅ Livraison créée automatiquement pour la commande #${cmd.id}`;
      this.loadCommandesPretes();  // Mettre à jour les commandes PRETE
      this.loadLivraisons();       // Mettre à jour la liste des livraisons
    },
    error: () => {
      this.errorMsg = `❌ Erreur lors de la création de la livraison pour la commande #${cmd.id}`;
    }
  });
}

}
