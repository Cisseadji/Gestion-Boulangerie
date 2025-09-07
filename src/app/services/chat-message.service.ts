import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import { Observable } from 'rxjs';

declare global {
  interface Window {
    Pusher: any;
  }
}

@Injectable({
  providedIn: 'root'
})
export class ChatMessageService {
  private echo: Echo<any>; 
  private apiUrl = 'http://127.0.0.1:8000/api/chatMessage'; // ⚠️ adapte ton URL API Laravel

  constructor(private http: HttpClient) {
    // Laravel Echo a besoin que Pusher soit global
    window.Pusher = Pusher;

    this.echo = new Echo({
      broadcaster: 'pusher',
      key: 'your-pusher-key',   // ⚠️ remplace par ta clé Pusher / WebSocket
      wsHost: '127.0.0.1',
      wsPort: 6001,
      forceTLS: false,
      disableStats: true,
      enabledTransports: ['ws', 'wss'],
    });
  }

  /** 📌 Récupérer tous les messages de l'utilisateur connecté */
  getMessages(): Observable<any> {
    return this.http.get(this.apiUrl);
  }

  /** 📌 Envoyer un message */
  sendMessage(data: any): Observable<any> {
    return this.http.post(this.apiUrl, data);
  }

  /** 📌 Marquer un message comme lu */
  markAsRead(id: number): Observable<any> {
    return this.http.put(`${this.apiUrl}/${id}/read`, {});
  }

  /** 📌 Écouter les nouveaux messages en temps réel */
  listenForMessages(userId: number, callback: (msg: any) => void) {
    this.echo.channel(`chat.${userId}`)
      .listen('NewChatMessage', (event: any) => {
        callback(event.message);
      });
  }
}
