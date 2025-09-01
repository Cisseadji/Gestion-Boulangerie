import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { TokenResponse } from '../models/token-response';
import { Login } from '../models/login';
import { Register } from '../models/register';



@Injectable({
  providedIn: 'root'
})
export class AuthService {

  URL = 'http://127.0.0.1:8000/api';

  constructor(private http: HttpClient) { }


  login(data: Login) {
    return this.http.post<TokenResponse>(`${this.URL}/login`, data);
  }

  register(data: Register) {
    return this.http.post<TokenResponse>(`${this.URL}/register`, data);
  }
  
 

  logOut() {
    return this.http.post(`${this.URL}/logout`, {});
  }

  saveToken(token: string) {
    localStorage.setItem('token', token);
  }
  getToken() {
    return localStorage.getItem('token');
  }

  removeToken() {
    return localStorage.removeItem('token');
  }

  getHeaders() {
    return {
      Authorization: 'Bearer ' + this.getToken()
    };
  }
  isAuthenticated(){
    return !!this.getToken();
  }

  getUserId(): number {
    return Number(localStorage.getItem('userId'));
  }
  getRole(): string {
    return localStorage.getItem('role') || '';
  }

  isAdmin(): boolean {
    return this.getRole() === 'ADMIN';
  }

  isEmploye(): boolean {
    return this.getRole() === 'EMPLOYE';
  }

  isClient(): boolean {
    return this.getRole() === 'CLIENT';
  }
}
