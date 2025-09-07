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

  // ✅ Récupérer une commande par ID
  getById(id: number): Observable<Commande> {
    return this.httpClient.get<Commande>(`${this.URL}/${id}`);
  }

  // ✅ Ajouter une commande (depuis le formulaire)
  addCommande(commande: Commande): Observable<Commande> {
    const data = this.prepareCommandeData(commande);
    return this.httpClient.post<Commande>(this.URL, data);
  }

  // ✅ Mettre à jour une commande complète
  updateCommande(id: number, commande: Commande): Observable<any> {
    const data = this.prepareCommandeData(commande);
    return this.httpClient.put(`${this.URL}/${id}`, data);
  }

  // ✅ Supprimer une commande
  deleteCommande(id: number): Observable<any> {
    return this.httpClient.delete(`${this.URL}/${id}`);
  }

  // ✅ Mettre à jour uniquement le statut
  updateStatut(id: number, statut: string): Observable<any> {
    return this.httpClient.patch(`${this.URL}/${id}/statut`, { statut });
  }

  // ✅ Ajouter une commande depuis le panier
  addCommandeFromCart(items: any[], mode_paiement: string = 'A_LA_LIVRAISON', adresse: string): Observable<Commande> {
    const produits = items.map(i => ({
      id: i.produit.id,
      quantite: i.quantity,
      prix_unitaire: i.produit.prix
    }));
    const total = produits.reduce((sum, p) => sum + (p.quantite * p.prix_unitaire), 0);

    const data = {
      id_client: this.auth.getUserId(),
      produits,
      total,
      mode_paiement,
      adresse,
      date_commande: new Date().toISOString()
    };

    return this.httpClient.post<Commande>(this.URL, data);
  }

  // ✅ Préparer les données à envoyer au backend
  private prepareCommandeData(commande: Commande) {
    const produits = commande.produits.map(p => ({
      id: p.id,
      quantite: p.quantite,
      prix_unitaire: p.prix_unitaire
    }));

    const total = produits.reduce((sum, p) => sum + (p.quantite * p.prix_unitaire), 0);

    return {
      id_client: commande.id_client,
      produits,
      total,
      statut: commande.statut || 'EN_PREPARATION',
      mode_paiement: commande.mode_paiement,
      adresse: commande.adresse,
      date_commande: commande.date_commande || new Date().toISOString()
    };
  }
}
