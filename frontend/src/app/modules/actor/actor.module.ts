import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {ActorRoutingModule} from "./actor-routing.module";
import { ActorComponent } from './actor/actor.component';
import {SharedModule} from "../../shared/shared.module";
import {ThemeModule} from "../../core/layout/theme.module";



@NgModule({
  declarations: [
    ActorComponent,
  ],
  imports: [
    CommonModule,
    ActorRoutingModule,
    ThemeModule,
    SharedModule
  ]
})
export class ActorModule { }
