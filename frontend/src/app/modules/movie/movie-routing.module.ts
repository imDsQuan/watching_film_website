import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {AllMovieComponent} from "./all-movie/all-movie.component";
import {MovieDetailComponent} from "./movie-detail/movie-detail.component";
import {MoviePlayerComponent} from "./movie-player/movie-player.component";
import {AfterLoginService} from "../../core/services/auth/after-login.service";

const routes: Routes = [
  {
    path: 'all',
    component: AllMovieComponent,
    canActivate: [AfterLoginService],
  },
  {
    path: ':slug/player',
    component: MoviePlayerComponent,
    canActivate: [AfterLoginService],
  }
  ,
  {
    path: ':slug',
    component: MovieDetailComponent,
    canActivate: [AfterLoginService],
  },




];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MovieRoutingModule { }
