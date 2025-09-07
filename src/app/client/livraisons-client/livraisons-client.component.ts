import { Component, OnInit } from '@angular/core';
import { LivraisonService } from '../../services/livraison.service';
import { Livraison } from '../../models/livraison';
import { AuthService } from '../../services/auth.service';
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-livraisons-client',
  templateUrl: './livraisons-client.component.html',
  styleUrls: ['./livraisons-client.component.css']
})
export class LivraisonsClientComponent implements OnInit {
  livraisons: Livraison[] = [];
  userId!: number;

  constructor(
    private livraisonService: LivraisonService,
    private auth: AuthService,
    private toastr: ToastrService
  ) {}

  ngOnInit() {
    this.userId = this.auth.getUserId();
    this.loadLivraisons();

    // Souscrire aux notifications temps réel
    this.livraisonService.statutChanges$.subscribe(livraison => {
      if (livraison.id_commande && livraison.id_commande === this.userId) {
        const index = this.livraisons.findIndex(l => l.id === livraison.id);
        if (index !== -1) this.livraisons[index].statut = livraison.statut;
        this.toastr.info(`Votre livraison #${livraison.id} est maintenant ${livraison.statut}`);
      }
    });
  }

  loadLivraisons() {
    this.livraisonService.getByClient(this.userId).subscribe(data => this.livraisons = data);
  }
}
