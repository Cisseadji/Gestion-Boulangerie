import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Commande } from '../models/commande';

@Injectable({
  providedIn: 'root'
})
export class EmployeService {

  private URL = "http://127.0.0.1:8000/api/employe";

  constructor(private http: HttpClient) {}

  // ✅ Récupérer toutes les commandes
  getCommandes(): Observable<Commande[]> {
    return this.http.get<Commande[]>(`${this.URL}/commandes`);
  }

  // ✅ Mettre à jour le statut d'une commande (EN_PREPARATION, PRETE, EN_LIVRAISON, LIVREE)
  updateStatutCommande(id: number, statut: string): Observable<any> {
    return this.http.patch(`${this.URL}/commande/${id}/statut`, { statut });
  }

  // ✅ Récupérer toutes les livraisons
  getLivraisons(): Observable<any> {
    return this.http.get(`${this.URL}/livraisons`);
  }

  // ✅ Mettre à jour le statut d'une livraison
  updateStatutLivraison(id: number, statut: string): Observable<any> {
    return this.http.patch(`${this.URL}/livraison/${id}/statut`, { statut });
  }

  // ✅ Récupérer les tickets/support clients
  getSupport(): Observable<any> {
    return this.http.get(`${this.URL}/support`);
  }

  // ✅ Répondre à un ticket/support client
  repondreSupport(data: any): Observable<any> {
    return this.http.post(`${this.URL}/support/reponse`, data);
  }
}
