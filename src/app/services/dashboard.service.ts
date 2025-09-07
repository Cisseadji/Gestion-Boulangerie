import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Commande } from '../models/commande';
import { Produit } from '../models/produit';
import { Promotion } from '../models/promotion';

@Injectable({
  providedIn: 'root'
})
export class DashboardService {
  private apiUrl = 'http://127.0.0.1:8000/api'; // ton backend Laravel

  constructor(private http: HttpClient) {}

  getStats(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/dashboard/stats`);
  }

  getCommandesRecentes(): Observable<Commande[]> {
    return this.http.get<Commande[]>(`${this.apiUrl}/dashboard/commandes-recentes`);
  }

  getProduitsPopulaires(): Observable<(Produit & { ventes: number, evolution: string })[]> {
    return this.http.get<(Produit & { ventes: number, evolution: string })[]>(`${this.apiUrl}/dashboard/produits-populaires`);
  }

  getPromotions(): Observable<Promotion[]> {
    return this.http.get<Promotion[]>(`${this.apiUrl}/dashboard/promotions`);
  }

  getVentes(): Observable<{ ventes: number; periode: string }[]> {
    return this.http.get<{ ventes: number; periode: string }[]>(`${this.apiUrl}/dashboard/ventes`);
  }
}
