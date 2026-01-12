  <ul class="steps steps-horizontal w-full max-w-sm">
      @foreach ($steps as $step)
          <li class="step {{ $step->isCurrent() ? 'step-primary font-bold' : '' }}">
              {{ $step->label }}
          </li>
      @endforeach
  </ul>
