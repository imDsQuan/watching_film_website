import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {ActorComponent} from "./actor/actor.component";
import {ActorDetailComponent} from "./actor-detail/actor-detail.component";

const routes: Routes = [
  {
    path: '',
    component: ActorComponent,
  },
  {
    path: ':id',
    component: ActorDetailComponent,
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ActorRoutingModule { }
