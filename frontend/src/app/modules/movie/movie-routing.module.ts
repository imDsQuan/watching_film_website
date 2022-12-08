import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {AllMovieComponent} from "./all-movie/all-movie.component";
import {MovieDetailComponent} from "./movie-detail/movie-detail.component";
import {MoviePlayerComponent} from "./movie-player/movie-player.component";

const routes: Routes = [
  {
    path: 'all',
    component: AllMovieComponent,
  },
  {
    path: ':slug/player',
    component: MoviePlayerComponent,
  }
  ,
  {
    path: ':slug',
    component: MovieDetailComponent,
  },




];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MovieRoutingModule { }
