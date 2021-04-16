import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms'; // form
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http'; // call api, INTERCEPTORS
import { AuthGuard } from './services/auth.guard'; // check login
import { RequestInterceptor } from './services/request.interceptor';
import { HeaderComponent } from './modules/admin/parts/header/header.component';
import { SidebarComponent } from './modules/admin/parts/sidebar/sidebar.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    SidebarComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule, // two-way binding
    ReactiveFormsModule, // form
    HttpClientModule, // call api
  ],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: RequestInterceptor,
      multi: true,
    },
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
