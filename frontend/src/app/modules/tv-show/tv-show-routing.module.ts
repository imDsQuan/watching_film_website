import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {AllTvshowComponent} from "./all-tvshow/all-tvshow.component";
import {TvshowDetailComponent} from "./tvshow-detail/tvshow-detail.component";
import {TvshowPlayerComponent} from "./tvshow-player/tvshow-player.component";

const routes: Routes = [
  {
    path: 'all',
    component: AllTvshowComponent,
  },
  {
    path: ':slug/episode/:episodeId',
    component: TvshowPlayerComponent,
  },
  {
    path: ':slug',
    component: TvshowDetailComponent,
  },

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TvShowRoutingModule { }
