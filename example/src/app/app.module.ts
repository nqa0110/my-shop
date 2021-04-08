import { RequestInterceptor } from './services/request.interceptor';
import { UserService } from 'src/app/services/user.service';
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { HttpClientModule } from '@angular/common/http';
import { AppComponent } from './app.component';
import { TopComponent } from './top/top/top.component';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
@NgModule({
  declarations: [AppComponent, TopComponent],
  imports: [BrowserModule, AppRoutingModule, HttpClientModule],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: RequestInterceptor,
      multi: true,
    },
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
