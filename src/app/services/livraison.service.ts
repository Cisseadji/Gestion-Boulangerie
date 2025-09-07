import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { AuthService } from './auth.service';
import { Observable, Subject } from 'rxjs';
import { Livraison } from '../models/livraison';

@Injectable({
  providedIn: 'root'
})
export class LivraisonService {
  
  private URL = "http://127.0.0.1:8000/api/livraison"; 

  // Pour notifications temps réel (via Subject)
  private statutSubject = new Subject<Livraison>();
  statutChanges$ = this.statutSubject.asObservable();
    
  constructor(private httpClient: HttpClient, private auth: AuthService) {}

  // Récupérer toutes les livraisons
  getAll(): Observable<Livraison[]> {
    return this.httpClient.get<Livraison[]>(this.URL, { headers: this.auth.getHeaders() });
  }

  // Récupérer les livraisons d’un client
  getByClient(userId: number): Observable<Livraison[]> {
    return this.httpClient.get<Livraison[]>(`${this.URL}/client/${userId}`, { headers: this.auth.getHeaders() });
  }

  // Récupérer une livraison par ID
  getById(id: number): Observable<Livraison> {
    return this.httpClient.get<Livraison>(`${this.URL}/${id}`, { headers: this.auth.getHeaders() });
  }

  // Créer une livraison (méthode harmonisée : store)
  store(livraison: Partial<Livraison>): Observable<Livraison> {
    return this.httpClient.post<Livraison>(this.URL, livraison, { headers: this.auth.getHeaders() });
  }

  // Modifier une livraison complète
  update(livraison: Livraison, id: number): Observable<Livraison> {
    return this.httpClient.put<Livraison>(`${this.URL}/${id}`, livraison, { headers: this.auth.getHeaders() });
  }

  // Supprimer une livraison
  delete(id: number): Observable<any> {
    return this.httpClient.delete(`${this.URL}/${id}`, { headers: this.auth.getHeaders() });
  }

  // Mettre à jour uniquement le statut
  updateStatut(id: number, statut: Livraison['statut']): Observable<any> {
    return this.httpClient.patch(`${this.URL}/${id}/statut`, { statut }, { headers: this.auth.getHeaders() });
  }

  // Notifier le changement de statut pour le client (ex: via WebSocket plus tard)
  notifyStatutChange(livraison: Livraison) {
    this.statutSubject.next(livraison);
  }
}
