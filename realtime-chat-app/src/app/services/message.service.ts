import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';
import {Observable} from 'rxjs';

@Injectable({ providedIn: 'root' })
export class MessageService {
  private baseUrl = environment.apiUrl;
  constructor(public http: HttpClient) {}

  // Register a user
  registerUser(userData: { name: string; email: string; password: string }): Observable<any> {
    return this.http.post(`${this.baseUrl}/api/register`, userData);
  }

  loginUser(userData: { email: string; password: string }): Observable<any> {
    return this.http.post(`${this.baseUrl}/api/login`, userData);
  }

  sendMessage(content: string) {
    const token = localStorage.getItem('token'); // token obtained after user login
    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
    return this.http.post<any>(`${this.baseUrl}/api/messages`, { content }, { headers });
  }
}
