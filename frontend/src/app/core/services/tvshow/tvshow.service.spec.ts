import { TestBed } from '@angular/core/testing';

import { TvshowService } from './tvshow.service';

describe('TvshowService', () => {
  let service: TvshowService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TvshowService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
