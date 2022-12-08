import { Component, OnInit } from '@angular/core';
import {Poster} from "../../../shared/models/poster/poster";
import {PaginationInstance} from "ngx-pagination";
import {MovieService} from "../../../core/services/movie/movie.service";
import {TvshowService} from "../../../core/services/tvshow/tvshow.service";

@Component({
  selector: 'app-all-tvshow',
  templateUrl: './all-tvshow.component.html',
  styleUrls: ['./all-tvshow.component.scss']
})
export class AllTvshowComponent implements OnInit {

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
    private tvshowService: TvshowService,
  ) {

  }

  ngOnInit(): void {
    this.tvshowService.getAll().subscribe(
      value => {
        console.log(value);
        this.lstMovie = value;
      }
    )
  }

}
