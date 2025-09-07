import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Facture } from '../../models/facture';
import { FactureService } from '../../services/facture.service';

@Component({
  selector: 'app-factures',
  templateUrl: './facture.component.html',
  styleUrls: ['./facture.component.css']
})
export class FactureComponent implements OnInit {

  factures: Facture[] = [];

  constructor(
    private factureService: FactureService,
    private authService: AuthService
  ) {}

  ngOnInit(): void {
    this.loadFactures();
  }

  loadFactures() {
    // Si client, filtrer ses factures
    if(this.authService.isClient()){
      const userId = this.authService.getUserId();
      this.factureService.getAll().subscribe({
        next: data => this.factures = data.filter(f => f.client?.id === userId),
        error: err => console.log(err)
      });
    } else {
      this.factureService.getAll().subscribe({
    next: data => {
      console.log('Factures reçues depuis API : ', data); // Vérifie si ta facture arrive bien
      this.factures = data;
    },
    error: err => console.log('Erreur API factures : ', err)
  });
    }
  }

  downloadPDF(id: number) {
    this.factureService.downloadPDF(id).subscribe(blob => {
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `facture_${id}.pdf`;
      a.click();
      window.URL.revokeObjectURL(url);
    });
  }

  sendMail(id: number) {
    this.factureService.sendMail(id).subscribe(() => {
      alert('Facture envoyée par mail !');
    });
  }

  deleteFacture(id: number) {
    if(confirm('Voulez-vous vraiment supprimer cette facture ?')) {
      this.factureService.deleteFacture(id).subscribe(() => {
        this.factures = this.factures.filter(f => f.id !== id);
      });
    }
  }

  isAdminOrEmploye(): boolean {
    return this.authService.isAdmin() || this.authService.isEmploye();
  }
}
