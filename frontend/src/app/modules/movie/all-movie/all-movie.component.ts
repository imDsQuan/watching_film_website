import {Component, Input, OnInit, ChangeDetectionStrategy} from '@angular/core';
import {Poster} from "../../../shared/models/poster/poster";

import {MovieService} from "../../../core/services/movie/movie.service";
import {PaginationInstance} from "ngx-pagination";

@Component({
  selector: 'app-all-movie',
  templateUrl: './all-movie.component.html',
  styleUrls: ['./all-movie.component.scss'],

})


export class AllMovieComponent implements OnInit {
  lstMovie: Poster[] = [];
  public maxSize: number = 7;
  public directionLinks: boolean = true;
  public autoHide: boolean = false;
  public responsive: boolean = false;
  public config: PaginationInstance = {
    id: 'advanced',
    itemsPerPage: 20,
    currentPage: 1
  };
  public labels: any = {
    previousLabel: 'Previous',
    nextLabel: 'Next',
    screenReaderPaginationLabel: 'Pagination',
    screenReaderPageLabel: 'page',
    screenReaderCurrentLabel: `You're on page`
  };
  public eventLog: string[] = [];

  private popped : Poster[] = [];

  onPageChange(number: number) {
    this.logEvent(`pageChange(${number})`);
    this.config.currentPage = number;
  }

  onPageBoundsCorrection(number: number) {
    this.logEvent(`pageBoundsCorrection(${number})`);
    this.config.currentPage = number;
  }

  pushItem() {
    let item = this.popped.pop() || new class implements Poster {
      coverImg = '';
      description =  '';
      posterImg =  '';
      slug =  '';
      title =  '';
    };
    this.lstMovie.push(<Poster> item);
  }

  popItem() {
    // @ts-ignore
    this.popped.push(this.lstMovie.pop());
  }

  private logEvent(message: string) {
    this.eventLog.unshift(`${new Date().toISOString()}: ${message}`)
  }

  constructor(
    private movieService: MovieService,
  ) {

  }

  ngOnInit(): void {
    this.movieService.getAll().subscribe(
      value => {
        console.log(value);
        this.lstMovie = value;
      }
    )
  }


}
