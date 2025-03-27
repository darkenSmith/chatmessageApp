import { Component, OnInit, OnDestroy, NgZone } from '@angular/core';
import { EchoService } from '../services/echo.service';
import { MessageService } from '../services/message.service';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-chat',
  standalone: true,
  imports: [
    FormsModule,
    CommonModule
  ],
  templateUrl: './chat.component.html'
})
export class ChatComponent implements OnInit, OnDestroy {
  newMessage: string = '';
  pendingMessages: any[] = [];
  processedMessages: any[] = [];
  userEmail: string = '';
  userName: string = '';
  password: string = '';
  isRegistered: boolean = false;
  loggedIn: boolean = false;

  constructor(
    private echoService: EchoService,
    private messageService: MessageService,
    private zone: NgZone  // Inject NgZone
  ) {}

  ngOnInit(): void {}

  // Method to handle user login
  loginUser(): void {
    const userData = {
      email: this.userEmail,
      password: this.password,
    };
    this.messageService.loginUser(userData).subscribe({
      next: (response) => {
        console.log('User Logged In:', response);
        localStorage.setItem('token', response.token);  // Store the token in localStorage
        localStorage.setItem('userId', response.user.id);
        this.loggedIn = true;

        // Initialize Echo after token is available
        this.echoService.initializeEcho();
      },
      error: (err) => console.error('Login failed', err)
    });
  }

  // Setup Echo to listen on a private channel after login
  setupEcho() {
    const userId = localStorage.getItem('userId');
    if (userId && this.echoService.echo) {
      this.echoService.echo.channel(`private-user.${userId}`)
        .listen(".MessageProcessed", (e: any) => {
          // Use NgZone to update Angular state
          this.zone.run(() => {
            console.log('Message processed:', e); // Debug log

            // Find the pending message and move it to processed, or add directly
            const idx = this.pendingMessages.findIndex(m => m.id === e.id);
            if (idx !== -1) {
              const [msg] = this.pendingMessages.splice(idx, 1);
              msg.status = 'completed';
              this.processedMessages.push(msg);
            } else {
              this.processedMessages.push(e);
            }
          });
        });
    }
  }

  // Method to send a message
  sendMessage(): void {
    this.setupEcho();
    const content = this.newMessage.trim();
    if (!content) return;
    this.messageService.sendMessage(content).subscribe({
      next: (msg) => {
        this.pendingMessages.push(msg);
        this.newMessage = '';
      },
      error: (err) => console.error('Message send failed', err)
    });
  }

  // Clean up Echo connection when the component is destroyed
  ngOnDestroy(): void {
    this.echoService.disconnect();
  }

  // Method to handle user registration
  registerUser() {
    if (this.userName && this.userEmail) {
      const userData = {
        name: this.userName,
        email: this.userEmail,
        password: this.password
      };

      this.messageService.registerUser(userData).subscribe({
        next: (response) => {
          console.log('User registered:', response);
          this.isRegistered = true;
          // After registration, log in the user
          this.loginUser();
        },
        error: (error) => {
          console.error('Error registering user:', error);
          alert('Registration failed. Please try again.');
        }
      });
    } else {
      alert('Please fill in both fields!');
    }
  }
}
