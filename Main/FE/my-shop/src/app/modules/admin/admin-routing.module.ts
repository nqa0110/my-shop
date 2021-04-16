import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from './../../services/auth.guard';

import { HomeComponent } from './home/home.component';
import { ExerciseComponent } from './exercise/exercise.component';

const routes: Routes = [
  {
    path: 'home',
    component: HomeComponent,
    children: [
      { path: '', component: ExerciseComponent },
      { path: 'exercise1', component: ExerciseComponent, outlet: 'route1' },
      { path: 'exercise2', component: ExerciseComponent, outlet: 'route2' },
    ],
    canActivate: [AuthGuard],
  },
  {
    path: 'exercise',
    component: ExerciseComponent,
    canActivate: [AuthGuard],
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AdminRoutingModule { }
