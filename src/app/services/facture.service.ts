import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { AuthService } from './auth.service';
import { Facture } from '../models/facture';

@Injectable({
  providedIn: 'root'
})
export class FactureService {

private URL = "http://127.0.0.1:8000/api/facture"; 
    
  constructor(private http: HttpClient, private auth: AuthService) { }

  // Récupérer toutes les factures
  getAll() {
    return this.http.get<Facture[]>(this.URL);
  }

  // Récupérer une facture par id
  getById(id: number) {
    return this.http.get<Facture>(`${this.URL}/${id}`);
  }

  // Créer une facture
  addFacture(data: any) {
    return this.http.post(`${this.URL}`, data);
  }

  // Mettre à jour une facture
  updateFacture(id: number, data: any) {
    return this.http.put(`${this.URL}/${id}`, data);
  }

  // Supprimer une facture
  deleteFacture(id: number) {
    return this.http.delete(`${this.URL}/${id}`);
  }

  // Télécharger le PDF d'une facture
  downloadPDF(id: number) {
  return this.http.get(`${this.URL}/${id}/download`, {
    responseType: 'blob', // <-- important
    headers: this.auth.getHeaders()
  });
}


  // Envoyer la facture par mail
  sendMail(id: number) {
    return this.http.post(`${this.URL}/${id}/send`, {});
  }
}
