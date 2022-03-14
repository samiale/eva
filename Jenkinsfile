pipeline {
  agent none
  stages {
    stage('build') {
      steps {
        build(job: 'build', propagate: true, quietPeriod: 4, wait: true)
      }
    }

  }
}