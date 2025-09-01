import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { AuthService } from './auth.service';
import { Produit } from '../models/produit';

@Injectable({
  providedIn: 'root'
})
export class ProduitService {

  private URL = "http://127.0.0.1:8000/api/produit"; 
    
    constructor(private httpClient : HttpClient, private auth :AuthService) { }
  
    getAll(){
        return  this.httpClient.get<Produit[]>(this.URL);
    }
  
    addProduit(produit: FormData) {
  return this.httpClient.post(`${this.URL}`, produit);
}

updateProduit(produit: FormData, id: number) {
  return this.httpClient.put(`${this.URL}/${id}`, produit);
}

deleteProduit(id: number){
    return this.httpClient.delete(this.URL+"/"+id);
}
getById(id: number){
    return this.httpClient.get<Produit>(this.URL+"/"+id);
}
  
}
