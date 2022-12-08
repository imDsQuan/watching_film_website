import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { MovieRoutingModule } from './movie-routing.module';
import { AllMovieComponent } from './all-movie/all-movie.component';
import {ThemeModule} from "../../core/layout/theme.module";
import {NgxPaginationModule} from "ngx-pagination";
import {SharedModule} from "../../shared/shared.module";
import { MovieDetailComponent } from './movie-detail/movie-detail.component';
import { MoviePlayerComponent } from './movie-player/movie-player.component';
import { VgCoreModule } from '@videogular/ngx-videogular/core';
import { VgControlsModule } from '@videogular/ngx-videogular/controls';
import { VgOverlayPlayModule } from '@videogular/ngx-videogular/overlay-play';
import { VgBufferingModule } from '@videogular/ngx-videogular/buffering';

@NgModule({
  declarations: [
    AllMovieComponent,
    MovieDetailComponent,
    MoviePlayerComponent,
  ],
  imports: [
    CommonModule,
    MovieRoutingModule,
    ThemeModule,
    NgxPaginationModule,
    SharedModule,
    VgCoreModule,
    VgControlsModule,
    VgOverlayPlayModule,
    VgBufferingModule,
  ]
})
export class MovieModule { }
