import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { AuthService } from './auth.service';
import { Commande } from '../models/commande';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CommandeService {

  private URL = "http://127.0.0.1:8000/api/commande"; 
    
  constructor(private httpClient: HttpClient, private auth: AuthService) { }

  // ✅ Récupérer toutes les commandes
  getAll(): Observable<Commande[]> {
    return this.httpClient.get<Commande[]>(this.URL);
  }

  // ✅ Ajouter une commande depuis le panier
addCommandeFromCart(items: any[], mode_paiement: string = 'A_LA_LIVRAISON'): Observable<Commande> {
  const data = {
    produits: items.map(i => ({
      id: i.produit.id,
      quantite: i.quantity
    })),
    mode_paiement // "EN_LIGNE" ou "A_LA_LIVRAISON"
  };
  return this.httpClient.post<Commande>(this.URL, data);
}



  // ✅ Récupérer une commande par ID
  getById(id: number): Observable<Commande> {
    return this.httpClient.get<Commande>(`${this.URL}/${id}`);
  }

  // ✅ Ajouter une commande
  addCommande(commande: Commande): Observable<Commande> {
    return this.httpClient.post<Commande>(this.URL, commande);
  }

  // ✅ Mettre à jour une commande complète
  updateCommande(id: number, commande: Commande): Observable<any> {
    return this.httpClient.put(`${this.URL}/${id}`, commande);
  }

  // ✅ Supprimer une commande
  deleteCommande(id: number): Observable<any> {
    return this.httpClient.delete(`${this.URL}/${id}`);
  }

  // ✅ Mettre à jour uniquement le statut
  updateStatut(id: number, statut: string): Observable<any> {
    return this.httpClient.patch(`${this.URL}/${id}/statut`, { statut });
  }
}
