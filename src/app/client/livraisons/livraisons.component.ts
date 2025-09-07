import { Component, OnInit } from '@angular/core';
import { Livraison } from '../../models/livraison';
import { LivraisonService } from '../../services/livraison.service';

@Component({
  selector: 'app-livraisons',
  templateUrl: './livraisons.component.html',
  styleUrls: ['./livraisons.component.css']
})
export class LivraisonsComponent implements OnInit {
  livraisons: Livraison[] = [];
  loading = false;
  errorMsg = '';
  successMsg = '';

  constructor(private livraisonService: LivraisonService) {}

  ngOnInit() {
    this.loadLivraisons();
  }

  // Charger toutes les livraisons
  loadLivraisons() {
    this.loading = true;
    this.livraisonService.getAll().subscribe({
      next: (data) => {
        this.livraisons = data;
        this.loading = false;
      },
      error: () => {
        this.errorMsg = 'Erreur lors du chargement des livraisons';
        this.loading = false;
      }
    });
  }

  // Mettre à jour le statut d'une livraison
  updateStatut(livraison: Livraison, statut: Livraison['statut']) {
    this.livraisonService.updateStatut(livraison.id, statut).subscribe({
      next: () => {
        livraison.statut = statut;
        this.successMsg = `Statut de la livraison #${livraison.id} mis à jour ✅`;
        this.errorMsg = '';
        this.livraisonService.notifyStatutChange(livraison);
      },
      error: () => {
        this.errorMsg = `Erreur lors de la mise à jour du statut de la livraison #${livraison.id}`;
        this.successMsg = '';
      }
    });
  }
}
