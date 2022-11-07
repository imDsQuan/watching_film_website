import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { MovieRoutingModule } from './movie-routing.module';
import { AllMovieComponent } from './all-movie/all-movie.component';
import {ThemeModule} from "../../core/layout/theme.module";
import {NgxPaginationModule} from "ngx-pagination";
import {SharedModule} from "../../shared/shared.module";
import { MovieDetailComponent } from './movie-detail/movie-detail.component';


@NgModule({
  declarations: [
    AllMovieComponent,
    MovieDetailComponent
  ],
  imports: [
    CommonModule,
    MovieRoutingModule,
    ThemeModule,
    NgxPaginationModule,
    SharedModule
  ]
})
export class MovieModule { }
