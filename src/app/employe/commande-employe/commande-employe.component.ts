import { Component, OnInit } from '@angular/core';
import { EmployeService } from '../../services/employe.service';
import { Commande } from '../../models/commande';

@Component({
  selector: 'app-commandes-employe',
  templateUrl: './commande-employe.component.html',
  styleUrls: ['./commande-employe.component.css']
})
export class CommandesEmployeComponent implements OnInit {

  commandes: Commande[] = [];
  loading: boolean = false;

  constructor(private employeService: EmployeService) {}

  ngOnInit(): void {
    this.loadCommandes();
  }

  loadCommandes() {
    this.loading = true;
    this.employeService.getCommandes().subscribe({
      next: (res) => {
        this.commandes = res;
        this.loading = false;
      },
      error: (err) => {
        console.error(err);
        this.loading = false;
        alert('Erreur lors du chargement des commandes.');
      }
    });
  }

  changerStatut(commande: Commande, nouveauStatut: string) {
    this.employeService.updateStatutCommande(commande.id, nouveauStatut).subscribe({
      next: (res) => {
        alert(`✅ Statut mis à jour: ${nouveauStatut}`);
        this.loadCommandes(); // recharge la liste
      },
      error: (err) => {
        console.error(err);
        alert('❌ Impossible de mettre à jour le statut.');
      }
    });
  }

}
