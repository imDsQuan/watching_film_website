import {Component, OnInit, TemplateRef} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {MovieService} from "../../../core/services/movie/movie.service";
import {Poster} from "../../../shared/models/poster/poster";
import {Genre} from "../../../shared/models/genre/Genre";
import {MatDialog} from "@angular/material/dialog";
import {TrailerPopUpComponent} from "../../../shared/components/trailer-pop-up/trailer-pop-up.component";
import {Actor} from "../../../shared/models/actor/actor";
import {UserService} from "../../../core/services/auth/user/user.service";
import {MyListService} from "../../../core/services/myList/my-list.service";
import {ToastrService} from "ngx-toastr";
import {User} from "../../../shared/models/user/User";
import {
  PaymentWarningPopupComponent
} from "../../../shared/components/payment-warning-popup/payment-warning-popup.component";


@Component({
  selector: 'app-movie-detail',
  templateUrl: './movie-detail.component.html',
  styleUrls: ['./movie-detail.component.scss']
})
export class MovieDetailComponent implements OnInit {

  slug: string | null | undefined;
  movie: Poster | undefined;
  lstGenres: Genre[] | undefined;
  lstCast: Actor[] | undefined;
  lstSimilar: Poster[] | undefined;
  user: User | undefined;
  constructor(
    private movieService: MovieService,
    private route: ActivatedRoute,
    private dialogRef: MatDialog,
    private User: UserService,
    private MyList: MyListService,
    private toastr: ToastrService,
    private router: Router,
  ) { }

  ngOnInit(): void {

    this.user = this.User.get();

    this.movieService.getBySlug(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        this.slug = this.route.snapshot.paramMap.get('slug');
        this.movie = data;
      }
    )

    this.movieService.getGenres(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        this.lstGenres = data;
      }
    )

    this.movieService.getCast(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        this.lstCast = data;
      }
    )

    this.movieService.getSimilar(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        this.lstSimilar = data;
      })
  }

  openPopup() {
    this.dialogRef.open(TrailerPopUpComponent, {
      data: {url: this.movie?.trailer},
    })
  }

  addToMyList() {
    this.toastr.success('Add Movie To List Successfully.');
    let data = {
      user_id : this.user?.id,
      poster_id: this.movie?.id,
    }
    this.MyList.addToList(data).subscribe(
      data => this.handleResponse(data),
    )
  }

  handleResponse(data: any) {

  }

  watchMovie() {

    let dateNow = new Date();

    let sub = this.user?.subscription;

    if(!sub) {
      this.dialogRef.open(PaymentWarningPopupComponent);
    }
    else {
      if (dateNow > new Date(sub.expired_date)) {
        this.dialogRef.open(PaymentWarningPopupComponent);
      } else {
        this.router.navigateByUrl(`/movie/${this.slug}/player`)
      }
    }
  }
}
