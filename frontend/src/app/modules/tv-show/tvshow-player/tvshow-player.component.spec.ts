import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TvshowPlayerComponent } from './tvshow-player.component';

describe('TvshowPlayerComponent', () => {
  let component: TvshowPlayerComponent;
  let fixture: ComponentFixture<TvshowPlayerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TvshowPlayerComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TvshowPlayerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
