import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Promotion } from '../models/promotion';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PromotionService {

  private URL = "http://127.0.0.1:8000/api/promotion"; 

  constructor(private httpClient: HttpClient) {}

  getAll(): Observable<Promotion[]> {
    return this.httpClient.get<Promotion[]>(this.URL);
  }

  getById(id: number): Observable<Promotion> {
    return this.httpClient.get<Promotion>(`${this.URL}/${id}`);
  }

  addPromotion(promotion: Promotion): Observable<Promotion> {
    return this.httpClient.post<Promotion>(this.URL, promotion);
  }

  updatePromotion(id: number, promotion: Promotion): Observable<Promotion> {
    return this.httpClient.put<Promotion>(`${this.URL}/${id}`, promotion);
  }

  deletePromotion(id: number): Observable<void> {
    return this.httpClient.delete<void>(`${this.URL}/${id}`);
  }

  togglePromotion(id: number, actif: boolean): Observable<Promotion> {
    return this.httpClient.patch<Promotion>(`${this.URL}/${id}/toggleActif`, { actif });
  }
}
