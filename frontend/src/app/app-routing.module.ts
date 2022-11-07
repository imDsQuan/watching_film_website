import { NgModule } from '@angular/core';
import { RouterModule, Routes, PreloadAllModules } from '@angular/router';

const routes: Routes = [
  { path: '', loadChildren: () => import('./modules/home/home.module').then(m => m.HomeModule)},
  { path: 'actor', loadChildren : () => import('./modules/actor/actor.module').then(m => m.ActorModule)},
  { path: 'movie', loadChildren : () => import('./modules/movie/movie.module').then(m => m.MovieModule)},
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {preloadingStrategy : PreloadAllModules})],
  exports: [RouterModule]
})
export class AppRoutingModule { }
