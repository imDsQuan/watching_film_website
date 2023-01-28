import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {ActorRoutingModule} from "./actor-routing.module";
import { ActorComponent } from './actor/actor.component';
import {SharedModule} from "../../shared/shared.module";
import {ThemeModule} from "../../core/layout/theme.module";
import { ActorDetailComponent } from './actor-detail/actor-detail.component';
import {NgxPaginationModule} from "ngx-pagination";



@NgModule({
  declarations: [
    ActorComponent,
    ActorDetailComponent,
  ],
    imports: [
        CommonModule,
        ActorRoutingModule,
        ThemeModule,
        SharedModule,
        NgxPaginationModule
    ]
})
export class ActorModule { }
