import { Component, OnInit } from '@angular/core';
import {Title} from "@angular/platform-browser";
import {Actor} from "../../../shared/models/actor/actor";
import {ActorService} from "../../../core/services/actor/actor.service";
import {PaginationInstance} from "ngx-pagination";

@Component({
  selector: 'app-actor',
  templateUrl: './actor.component.html',
  styleUrls: ['./actor.component.scss']
})
export class ActorComponent implements OnInit {
  lstActor : Actor[] = [];
  config: PaginationInstance = {
    id: 'advanced',
    itemsPerPage: 20,
    currentPage: 1
  };

  public maxSize: number = 7;
  public directionLinks: boolean = true;
  public autoHide: boolean = false;
  public responsive: boolean = false;

  public labels: any = {
    previousLabel: 'Previous',
    nextLabel: 'Next',
    screenReaderPaginationLabel: 'Pagination',
    screenReaderPageLabel: 'page',
    screenReaderCurrentLabel: `You're on page`
  };

  constructor(
    private titleService: Title,
    private actorService: ActorService,

  ) {
    titleService.setTitle('ShineFlex - All Actor')
  }

  ngOnInit(): void {
    this.actorService.getAll().subscribe(
      (value) => {
        this.lstActor = value
      }
    );
  }

  onPageChange(number: number) {
    this.logEvent(`pageChange(${number})`);
    this.config.currentPage = number;
  }

  onPageBoundsCorrection(number: number) {
    this.logEvent(`pageBoundsCorrection(${number})`);
    this.config.currentPage = number;
  }

  private logEvent(message: string) {
    this.eventLog.unshift(`${new Date().toISOString()}: ${message}`)
  }

  public eventLog: string[] = [];

}
