import {Component, OnInit, TemplateRef} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {MovieService} from "../../../core/services/movie/movie.service";
import {Poster} from "../../../shared/models/poster/poster";
import {Genre} from "../../../shared/models/genre/Genre";
import {ModalDismissReasons, NgbModal} from "@ng-bootstrap/ng-bootstrap";

@Component({
  selector: 'app-movie-detail',
  templateUrl: './movie-detail.component.html',
  styleUrls: ['./movie-detail.component.scss']
})
export class MovieDetailComponent implements OnInit {

  movie: Poster | undefined;
  lstGenres: Genre[] | undefined;
  private closeResult: string | undefined;
  constructor(
    private movieService: MovieService,
    private route: ActivatedRoute,
    private modalService: NgbModal
  ) { }

  ngOnInit(): void {
    this.movieService.getBySlug(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        console.log(data);
        this.movie = data;
      }
    )

    this.movieService.getGenres(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        this.lstGenres = data;
      }
    )
  }

  open(content: TemplateRef<any>) {
    this.modalService.open(content, { ariaLabelledBy: 'modal-basic-title' }).result.then(
      (result: any) => {
        this.closeResult = `Closed with: ${result}`;
      },
      (reason: any) => {
        this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
      },
    );
  }

  private getDismissReason(reason : any) {
    if (reason === ModalDismissReasons.ESC) {
      return 'by pressing ESC';
    } else if (reason === ModalDismissReasons.BACKDROP_CLICK) {
      return 'by clicking on a backdrop';
    } else {
      return `with: ${reason}`;
    }
  }
}
