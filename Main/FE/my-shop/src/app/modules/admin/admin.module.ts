import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AdminRoutingModule } from './admin-routing.module';
import { HomeComponent } from './home/home.component';
import { ExerciseComponent } from './exercise/exercise.component';
import { HeaderComponent } from './parts/header/header.component';
import { SidebarComponent } from './parts/sidebar/sidebar.component';


@NgModule({
  declarations: [HomeComponent, ExerciseComponent, HeaderComponent, SidebarComponent],
  imports: [
    CommonModule,
    AdminRoutingModule
  ]
})
export class AdminModule { }
