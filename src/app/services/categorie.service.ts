import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { AuthService } from './auth.service';
import { Categorie } from '../models/categorie';

@Injectable({
  providedIn: 'root'
})
export class CategorieService {
  private URL = "http://127.0.0.1:8000/api/categorie"; 
  
  constructor(private httpClient : HttpClient, private auth :AuthService) { }

  getAll(){
      return  this.httpClient.get<Categorie[]>(this.URL);
  }

  addCategorie(categorie : Categorie){
    return this.httpClient.post<Categorie>(this.URL, categorie);
  }
  updateCategorie(categorie : Categorie, id:number){
    return this.httpClient.put<Categorie>(this.URL+"/"+id, categorie);
  }
  deleteCategorie(id: number){
     return this.httpClient.delete(this.URL+"/"+id);
  }
  getById(id: number){
     return this.httpClient.get<Categorie>(this.URL+"/"+id);
  }

}
