import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TvShowRoutingModule } from './tv-show-routing.module';
import { AllTvshowComponent } from './all-tvshow/all-tvshow.component';
import {NgxPaginationModule} from "ngx-pagination";
import {SharedModule} from "../../shared/shared.module";
import {ThemeModule} from "../../core/layout/theme.module";
import { TvshowDetailComponent } from './tvshow-detail/tvshow-detail.component';
import {MatFormFieldModule} from "@angular/material/form-field";
import {MatSelectModule} from "@angular/material/select";
import {FormsModule} from "@angular/forms";
import { TvshowPlayerComponent } from './tvshow-player/tvshow-player.component';
import {VgCoreModule} from "@videogular/ngx-videogular/core";
import {VgOverlayPlayModule} from "@videogular/ngx-videogular/overlay-play";
import {VgBufferingModule} from "@videogular/ngx-videogular/buffering";
import {VgControlsModule} from "@videogular/ngx-videogular/controls";


@NgModule({
  declarations: [
    AllTvshowComponent,
    TvshowDetailComponent,
    TvshowPlayerComponent
  ],
  imports: [
    CommonModule,
    TvShowRoutingModule,
    NgxPaginationModule,
    SharedModule,
    ThemeModule,
    MatFormFieldModule,
    MatSelectModule,
    FormsModule,
    VgCoreModule,
    VgOverlayPlayModule,
    VgBufferingModule,
    VgControlsModule
  ]
})
export class TvShowModule { }
