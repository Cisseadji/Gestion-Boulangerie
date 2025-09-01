import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { AuthService } from './auth.service';
import { User } from '../models/user';

@Injectable({
  providedIn: 'root'
})
export class UserService {
   private URL = "http://127.0.0.1:8000/api/users"; 

  constructor(private httpClient: HttpClient, private auth: AuthService) {}

  getAll() {
    return this.httpClient.get<User[]>(this.URL);
  }

  addUser(user: User) {
    return this.httpClient.post<User>(this.URL, user);
  }

  updateUser(id: number, user: User) {
    return this.httpClient.put<User>(`${this.URL}/${id}`, user);
  }

  deleteUser(id: number) {
    return this.httpClient.delete(`${this.URL}/${id}`);
  }

  getById(id: number) {
    return this.httpClient.get<User>(`${this.URL}/${id}`);
  }

  
}
