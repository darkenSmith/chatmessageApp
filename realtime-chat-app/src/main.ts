import { bootstrapApplication } from '@angular/platform-browser';
import { importProvidersFrom } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { ChatComponent } from './app/chat/chat.component';

bootstrapApplication(ChatComponent, {
  providers: [importProvidersFrom(HttpClientModule)]
});
