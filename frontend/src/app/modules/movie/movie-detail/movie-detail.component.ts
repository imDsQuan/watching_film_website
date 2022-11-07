import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {MovieService} from "../../../core/services/movie/movie.service";
import {Poster} from "../../../shared/models/poster/poster";

@Component({
  selector: 'app-movie-detail',
  templateUrl: './movie-detail.component.html',
  styleUrls: ['./movie-detail.component.scss']
})
export class MovieDetailComponent implements OnInit {

  movie: Poster | undefined;

  constructor(
    private movieService: MovieService,
    private route: ActivatedRoute,
  ) { }

  ngOnInit(): void {
    this.movieService.getBySlug(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        console.log(data);
        this.movie = data;
      }
    )
  }

}
