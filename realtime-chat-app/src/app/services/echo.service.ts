import { Injectable } from '@angular/core';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import { environment } from '../../environments/environment';

@Injectable({ providedIn: 'root' })
export class EchoService {
  public echo: any;
  // Get the CSRF token from cookies
  constructor() {
    // Attach Pusher to the global window object
    (window as any).Pusher = Pusher;
    // Initialize Echo with your Reverb configuration
  }

  // Initialize Echo after login when the token is available.
  initializeEcho() {
    const token = localStorage.getItem('token');
    if (!token) {
      console.error('Token is not available for Echo initialization');
      return;
    }
    this.echo = new Echo({
      broadcaster: 'reverb',
      key: environment.reverbAppKey,
      wsHost: environment.reverbHost,
      wsPort: environment.reverbPort || 80,
      wssPort: environment.reverbPort || 443,
      forceTLS: (environment.reverbScheme || 'https') === 'https',
      enabledTransports: ['ws', 'wss'],
      authEndpoint: `${environment.apiUrl}/broadcasting/auth`,
      auth: {
        headers: {
          Authorization: `Bearer ${token}`, // token set after login
        }
      }
    });
    console.log('Echo initialized:', this.echo);
    this.echo.connector.pusher.connection.bind('connected', () => {
      console.log('WebSocket connected successfully');
    });
    this.echo.connector.pusher.connection.bind('error', (err: any) => {
      console.error('WebSocket connection error:', err);
    });
  }

  disconnect() {
    if (this.echo) {
      this.echo.disconnect();
    }
  }
}
